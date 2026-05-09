<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini Social Posts</title>
    <style>
        body {
            margin: 0;
            background: #f5f7fb;
            color: #172033;
            font-family: Arial, Helvetica, sans-serif;
        }

        .page {
            max-width: 760px;
            margin: 0 auto;
            padding: 32px 16px;
        }

        .topbar {
            align-items: center;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .panel,
        .post {
            background: #fff;
            border: 1px solid #dde3ee;
            border-radius: 8px;
            padding: 18px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
        }

        h1 {
            margin: 0 0 18px;
            font-size: 28px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
        }

        input,
        textarea {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 12px;
            font: inherit;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        button {
            border: 0;
            border-radius: 6px;
            background: #2563eb;
            color: #fff;
            cursor: pointer;
            font-weight: 700;
            padding: 10px 16px;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }

        .links {
            align-items: center;
            display: flex;
            gap: 12px;
        }

        .logout {
            background: #475569;
        }

        .field {
            margin-bottom: 14px;
        }

        .alert {
            border-radius: 6px;
            margin-bottom: 14px;
            padding: 10px 12px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .feed {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        .meta {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .body {
            line-height: 1.5;
            white-space: pre-line;
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <h1>Mini Social Posts</h1>
            <nav class="links">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout" type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </nav>
        </header>

        <section class="panel">
            @if (session('status'))
                <div class="alert success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert error">{{ $errors->first() }}</div>
            @endif

            @auth
                <form method="POST" action="{{ route('posts.store') }}">
                    @csrf

                    <div class="field">
                        <label for="body">Post as {{ auth()->user()->name }}</label>
                        <textarea id="body" name="body" required>{{ old('body') }}</textarea>
                    </div>

                    <button type="submit">Publish Post</button>
                </form>
            @else
                <div class="body">
                    <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">register</a> to publish a post.
                </div>
            @endauth
        </section>

        <section class="feed">
            @forelse ($posts as $post)
                <article class="post">
                    <div class="meta">
                        {{ $post->author_name }} posted {{ $post->created_at->diffForHumans() }}
                    </div>
                    <div class="body">{{ $post->body }}</div>
                </article>
            @empty
                <article class="post">
                    <div class="body">No posts yet.</div>
                </article>
            @endforelse
        </section>
    </main>
</body>
</html>
