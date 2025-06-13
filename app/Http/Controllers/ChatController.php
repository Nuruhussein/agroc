<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index(Request $request, $receiverId = null)
    {
        // Fetch all conversations
        $conversations = Message::selectRaw('
            CASE 
                WHEN sender_id = ? THEN receiver_id
                ELSE sender_id
            END as contact_id,
            MAX(created_at) as last_message_time
        ', [Auth::id()])
        ->where(function ($query) {
            $query->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
        })
        ->groupBy('contact_id')
        ->orderBy('last_message_time', 'desc')
        ->get();

        // Load contact details for each conversation
        $conversations->each(function ($conversation) {
            $conversation->contact = User::select('id', 'name', 'role', 'profile_picture')
                ->find($conversation->contact_id);
        });

        $messages = [];
        $receiver = null;

        // Fetch farmers (users with role 'farmer')
        $farmers = User::select('id', 'name', 'profile_picture')
            ->where('role', 'farmer')
            ->where('id', '!=', Auth::id())
            ->get();

        // If a receiver is selected, fetch messages
        if ($receiverId) {
            $receiver = User::findOrFail($receiverId);
            $messages = Message::where(function ($query) use ($receiverId) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $receiverId);
            })->orWhere(function ($query) use ($receiverId) {
                $query->where('sender_id', $receiverId)
                      ->where('receiver_id', Auth::id());
            })->with(['sender', 'receiver'])
              ->orderBy('created_at', 'asc')
              ->get();

            // Mark received messages as read
            Message::where('receiver_id', Auth::id())
                   ->where('sender_id', $receiverId)
                   ->where('is_read', false)
                   ->update(['is_read' => true]);
        }

        return Inertia::render('Chat/Index', [
            'conversations' => $conversations,
            'messages' => $messages,
            'receiver' => $receiver,
            'currentUser' => Auth::user(),
            'farmers' => $farmers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        $originalName = null;
        $mimeType = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imagePath = $file->store('chat_images', 'public');
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'image_path' => $imagePath,
            'image_original_name' => $originalName,
            'mime_type' => $mimeType,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    public function update(Request $request, Message $message)
    {
        // Authorize: Only the sender can edit the message
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $message->image_path;
        $originalName = $message->image_original_name;
        $mimeType = $message->mime_type;

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $file = $request->file('image');
            $imagePath = $file->store('chat_images', 'public');
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();
        }

        $message->update([
            'message' => $request->message,
            'image_path' => $imagePath,
            'image_original_name' => $originalName,
            'mime_type' => $mimeType,
        ]);

        return redirect()->back()->with('success', 'Message updated successfully');
    }

    public function destroy(Message $message)
    {
        // Authorize: Only the sender can delete the message
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete associated image if it exists
        if ($message->image_path) {
            Storage::disk('public')->delete($message->image_path);
        }

        $message->delete();

        return redirect()->back()->with('success', 'Message deleted successfully');
    }
}