<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Post Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        .meta-table th, .meta-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .meta-table th {
            background-color: #f8f9fa;
            width: 25%;
        }
        .color-box {
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 3px;
            vertical-align: middle;
            border: 1px solid #ccc;
        }
        .badge {
            background-color: #e2e8f0;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            margin-right: 3px;
        }
        .content-box {
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #fafafa;
            border-radius: 4px;
            margin-top: 10px;
        }
        .post-image {
            max-width: 100%;
            height: auto;
            max-height: 250px;
            display: block;
            margin: 15px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>

@foreach($records as $record)
    <h1>{{ $record->title }}</h1>
    <p style="text-align: center; color: #666; font-size: 11px;">Slug: {{ $record->slug }}</p>

    {{-- Main Details Table --}}
    <table class="meta-table">
        <tr>
            <th>ID</th>
            <td>{{ $record->id }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $record->category?->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Color</th>
            <td>
                @if($record->color)
                    <span class="color-box" style="background-color: {{ $record->color }};"></span>
                    {{ $record->color }}
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $record->published ? 'Published' : 'Draft' }}</td>
        </tr>
        <tr>
            <th>Published At</th>
            <td>{{ $record->published_at ? $record->published_at->format('Y-m-d H:i') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>Tags</th>
            <td>
                @forelse($record->tags as $tag)
                    <span class="badge">{{ $tag->name }}</span>
                @empty
                    No tags
                @endforelse
            </td>
        </tr>
    </table>

    {{-- Cover Image (if uploaded) --}}
    @if($record->image)
        <div>
            <strong>Featured Image:</strong><br>
            <img src="{{ public_path('storage/' . $record->image) }}" class="post-image" alt="Post Image">
        </div>
    @endif

    {{-- Render Markdown/HTML Body --}}
    <strong>Content:</strong>
    <div class="content-box">
        {!! Str::markdown($record->body ?? '<em>No content provided.</em>') !!}
    </div>

    @if(!$loop->last)
        <div style="page-break-after: always;"></div>
    @endif
@endforeach

</body>
</html>
