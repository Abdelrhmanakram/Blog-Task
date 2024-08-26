<!DOCTYPE html>
<html>
<head>
    <title>New Comment Notification</title>
</head>
<body>
    <h1>New Comment on Your Post</h1>
    <p>Hello {{ $comment->post->user->name }},</p>
    <p>A new comment has been made on your post "{{ $comment->post->title }}".</p>
    <p><strong>Comment:</strong></p>
    <p>{{ $comment->content }}</p>
    <p><strong>Commented by:</strong> {{ $comment->user->name }}</p>
    <p>Thank you!</p>
</body>
</html>
