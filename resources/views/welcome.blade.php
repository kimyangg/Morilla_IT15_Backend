<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style>
            :root {
                --bg: #f7f7f7;
                --panel: #ffffff;
                --text: #222222;
                --muted: #666666;
                --border: #dddddd;
            }

            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: Arial, sans-serif;
                background: var(--bg);
                color: var(--text);
                min-height: 100vh;
                padding: 24px;
            }

            .page {
                max-width: 960px;
                margin: 0 auto;
            }

            header {
                margin-bottom: 16px;
            }

            h1 {
                font-size: 22px;
                font-weight: 600;
                margin-bottom: 4px;
            }

            .subtitle {
                color: var(--muted);
                font-size: 14px;
            }

            .layout {
                display: grid;
                grid-template-columns: 200px 1fr;
                gap: 16px;
            }

            .sidebar,
            .content {
                background: var(--panel);
                border: 1px solid var(--border);
                border-radius: 6px;
                padding: 12px;
            }

            .sidebar h2 {
                font-size: 14px;
                margin-bottom: 8px;
            }

            .category-list {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .category-link {
                display: block;
                padding: 8px 10px;
                border-radius: 4px;
                text-decoration: none;
                color: var(--text);
                border: 1px solid transparent;
            }

            .category-link.active,
            .category-link:hover {
                border-color: var(--border);
                background: #f0f0f0;
            }

            .content-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .content-header h2 {
                font-size: 16px;
            }

            .content-header span {
                font-size: 12px;
                color: var(--muted);
            }

            .card-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 12px;
            }

            .card {
                border: 1px solid var(--border);
                border-radius: 6px;
                padding: 10px;
                background: #fff;
            }

            .card h3 {
                font-size: 14px;
                margin-bottom: 6px;
            }

            .card p {
                font-size: 13px;
                color: var(--muted);
                line-height: 1.4;
            }

            .empty {
                border: 1px dashed var(--border);
                border-radius: 6px;
                padding: 12px;
                color: var(--muted);
            }

            @media (max-width: 800px) {
                .layout {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <header>
                <h1>Simple Post Board</h1>
                <p class="subtitle">Pick a category to filter the posts.</p>
            </header>

            <div class="layout">
                <aside class="sidebar">
                    <h2>Categories</h2>
                    <div class="category-list">
                        @forelse ($categories as $category)
                            <a
                                class="category-link {{ $activeCategory && $activeCategory->id === $category->id ? 'active' : '' }}"
                                href="{{ url('/?category=' . $category->slug) }}"
                            >
                                {{ $category->name }}
                            </a>
                        @empty
                            <span class="subtitle">No categories yet.</span>
                        @endforelse
                    </div>
                </aside>

                <section class="content">
                    <div class="content-header">
                        <h2>{{ $activeCategory?->name ?? 'Posts' }}</h2>
                        <span>{{ $posts->count() }} post{{ $posts->count() === 1 ? '' : 's' }}</span>
                    </div>

                    @if ($posts->isEmpty())
                        <div class="empty">No posts found for this category.</div>
                    @else
                        <div class="card-grid">
                            @foreach ($posts as $post)
                                <article class="card">
                                    <h3>{{ $post->title }}</h3>
                                    <p>{{ $post->description }}</p>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </body>
</html>
