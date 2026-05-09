<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body { margin: 0; background: #f5f7fb; color: #172033; font-family: Arial, Helvetica, sans-serif; }
        .page { max-width: 420px; margin: 0 auto; padding: 48px 16px; }
        .panel { background: #fff; border: 1px solid #dde3ee; border-radius: 8px; padding: 22px; box-shadow: 0 1px 2px rgba(15, 23, 42, .04); }
        h1 { margin: 0 0 18px; font-size: 26px; }
        label { display: block; margin-bottom: 6px; font-weight: 700; }
        input { width: 100%; box-sizing: border-box; border: 1px solid #cbd5e1; border-radius: 6px; padding: 10px 12px; font: inherit; }
        button { border: 0; border-radius: 6px; background: #2563eb; color: #fff; cursor: pointer; font-weight: 700; padding: 10px 16px; }
        a { color: #2563eb; text-decoration: none; }
        .field { margin-bottom: 14px; }
        .row { align-items: center; display: flex; justify-content: space-between; gap: 12px; }
        .check { align-items: center; display: flex; gap: 8px; margin-bottom: 16px; }
        .check input { width: auto; }
        .error { background: #fee2e2; border-radius: 6px; color: #991b1b; margin-bottom: 14px; padding: 10px 12px; }
        .nav { margin-bottom: 16px; }
    </style>
</head>
<body>
    <main class="page">
        <div class="nav"><a href="{{ route('posts.index') }}">View posts</a></div>
        <section class="panel">
            <h1>Login</h1>

            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <label class="check">
                    <input type="checkbox" name="remember" value="1">
                    Remember me
                </label>

                <div class="row">
                    <button type="submit">Login</button>
                    <a href="{{ route('register') }}">Create account</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
