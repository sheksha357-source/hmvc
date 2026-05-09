<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        body { margin: 0; background: #f5f7fb; color: #172033; font-family: Arial, Helvetica, sans-serif; }
        .page { max-width: 860px; margin: 0 auto; padding: 28px 16px; }
        .topbar { align-items: center; display: flex; justify-content: space-between; gap: 16px; margin-bottom: 18px; }
        .links { align-items: center; display: flex; gap: 12px; }
        .panel, .post { background: #fff; border: 1px solid #dde3ee; border-radius: 8px; padding: 18px; box-shadow: 0 1px 2px rgba(15, 23, 42, .04); }
        h1 { margin: 0; font-size: 28px; }
        h2 { margin: 0 0 14px; font-size: 20px; }
        label { display: block; margin-bottom: 6px; font-weight: 700; }
        textarea { width: 100%; box-sizing: border-box; border: 1px solid #cbd5e1; border-radius: 6px; min-height: 110px; padding: 10px 12px; resize: vertical; font: inherit; }
        button { border: 0; border-radius: 6px; background: #2563eb; color: #fff; cursor: pointer; font-weight: 700; padding: 10px 16px; }
        .logout { background: #475569; }
        a { color: #2563eb; text-decoration: none; }
        .field { margin-bottom: 14px; }
        .alert { border-radius: 6px; margin-bottom: 14px; padding: 10px 12px; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .feed { display: grid; gap: 12px; margin-top: 18px; }
        .meta { color: #64748b; font-size: 14px; margin-bottom: 8px; }
        .body { line-height: 1.5; white-space: pre-line; }
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <div>
                <h1>Dashboard</h1>
                <div class="meta">Signed in as {{ auth()->user()->name }}</div>
            </div>
            <nav class="links">
                <a href="{{ route('posts.index') }}">Public feed</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout" type="submit">Logout</button>
                </form>
            </nav>
        </header>

        <section class="panel">
            <h2>Create Post</h2>

            @if (session('status'))
                <div class="alert success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('posts.store') }}">
                @csrf
                <div class="field">
                    <label for="body">Post</label>
                    <textarea id="body" name="body" required>{{ old('body') }}</textarea>
                </div>
                <button type="submit">Publish Post</button>
            </form>
        </section>

        <section class="feed">
            <h2>Your Posts</h2>
            @forelse ($posts as $post)
                <article class="post">
                    <div class="meta">{{ $post->created_at->diffForHumans() }}</div>
                    <div class="body">{{ $post->body }}</div>
                </article>
            @empty
                <article class="post">
                    <div class="body">You have not posted yet.</div>
                </article>
            @endforelse
        </section>
    </main>
</body>
</html>
