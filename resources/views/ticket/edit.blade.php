<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Update Ticket</h1>

    <a href="{{ route('ticket.index') }}" class="btn btn-secondary mt-2 btn-sm">Back to Table</a>

    <form class="mt-5" action="{{ route('ticket.update', $ticket->id) }}" method="POST">
        @method('PUT')
        @csrf

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="form-group">
            <label for="name">Customer name</label>
            <input type="text" class="form-control" name="name" value="{{ $ticket->name }}" placeholder="Enter name" readonly>
        </div>
        <div class="form-group">
            <label for="problem_description">Problem Description</label>
            <input type="text" class="form-control" name="problem_description" value="{{ $ticket->problem_description }}" placeholder="Enter description" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $ticket->email }}" placeholder="Enter email" readonly>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="number" class="form-control" name="phone" value="{{ $ticket->phone }}" placeholder="Enter phone" readonly>
        </div>
        <div class="form-group">
            <label for="reply">Reply</label>
            <textarea class="form-control" name="reply" placeholder="Enter your reply">{{ isset($ticket->reply) ? $ticket->reply : '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3" id="replyButton">Reply</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const replyField = document.querySelector('textarea[name="reply"]');
            const replyButton = document.getElementById('replyButton');
            if (replyField.value.trim() !== "") {
                replyButton.disabled = true;
            }
        });
    </script>
</body>
</html>
