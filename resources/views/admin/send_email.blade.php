<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Order Email</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            font-family: 'Roboto', sans-serif;
            color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #1e1e2f;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #00d8ff;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: none;
            border-radius: 6px;
            background: #2a2a3c;
            color: #fff;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            background: #00d8ff;
            color: #1e1e2f;
            padding: 14px;
            border: none;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
            font-size: 16px;
        }

        button:hover {
            background-color: #00bcd4;
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            color: #ccc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Send Email to {{ $order->email }}</h2>

        <form action="{{ url('order/send-mail/' . $order->id) }}" method="POST">
            @csrf

            <label for="greeting">Email Greeting</label>
            <input type="text" id="greeting" name="greeting" placeholder="e.g., Hello John!" required>

            <label for="firstline">Email First Line</label>
            <input type="text" id="firstline" name="firstline" placeholder="e.g., Your order has been shipped." required>

            <label for="body">Email Body</label>
            <textarea id="body" name="body" placeholder="Detailed message about the order..." required></textarea>

            <label for="button">Email Button Name</label>
            <input type="text" id="button" name="button" placeholder="e.g., Track Order" required>

            <label for="url">Email Button URL</label>
            <input type="url" id="url" name="url" placeholder="https://example.com/track-order" required>

            <label for="lastline">Email Last Line</label>
            <input type="text" id="lastline" name="lastline" placeholder="e.g., Thank you for shopping with us!" required>

            <button type="submit">Send Email</button>
        </form>

        <div class="back-link">
            <a href="{{ url()->previous() }}">← Back to Orders</a>
        </div>
    </div>
</body>
</html>
