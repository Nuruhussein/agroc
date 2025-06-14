<!DOCTYPE html>
<html>
<head>
    <title>Order Delivery Update</title>
    <!-- Tailwind CSS CDN for email styling -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto my-8 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            Hello, {{ $orderItem->order->buyer->name }}!
        </h2>

        <p class="text-gray-600 mb-4">
            We're pleased to inform you that your order item
            <strong class="text-purple-600">{{ $orderItem->produce->name }}</strong>
            has been marked as
            <strong class="text-{{ $newStatus === 'delivered' ? 'green' : ($newStatus === 'shipped' ? 'blue' : 'yellow') }}-600">
                {{ ucfirst($newStatus) }}
            </strong>
            by the farmer.
        </p>

        <!-- Reporting Link for Delivered Status -->
        <div v-if="$newStatus === 'delivered'" class="mb-4">
            <p class="text-gray-600 mb-2">If you have any issues with this delivery, you can report the farmer:</p>
            <a href="{{ url('/buyer/report/' . $orderItem->id) }}"
               class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Report Farmer
            </a>
        </div>

        <p class="text-gray-600">Thank you for shopping with Agroc!</p>

        <!-- Footer -->
        <div class="mt-6 text-center text-gray-500 text-sm">
            <p>If you have any questions, contact us at <a href="mailto:support@agroc.com" class="text-purple-600 hover:underline">support@agroc.com</a>.</p>
        </div>
    </div>
</body>
</html>