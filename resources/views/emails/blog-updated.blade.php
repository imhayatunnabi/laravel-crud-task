<!DOCTYPE html>
<html>
<head>
    <title>Blog Updated</title>
</head>
<body>
    <h1>Your Blog Post Has Been Updated</h1>
    <p>Dear {{ $blog->creator->name }},</p>
    <p>Your blog post titled "<strong>{{ $blogTitle }}</strong>" has been updated by {{ $updatingUserName }}.</p>
    <p>Thank you for using our platform!</p>
</body>
</html>
