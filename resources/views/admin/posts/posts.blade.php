<x-admin-app-layout>
    @section('title')
    {{ $title }}
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin - Manage Posts') }}

        @if($gen_helper::check_privillege("create_posts"))
        <a href="{{ url('admin/posts/create') }}" style="color:#f11; float:right;" class="text-sm sm:ml-0">New Post</a>
        @endif
        </h2>
    </x-slot>

    <div class="py-4 min-h-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <x-message />

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
        <form method="post" action="{{ url('admin/posts/search') }}">
            @csrf
            <table class="search-tb"><tbody><tr>
            <td><input type="text" name="search" placeholder="Enter title or body content" value="{{ session('admin-posts-search') }}"></td>
            <td class="search-btn-td"><x-primary-button class="ms-3"> {{ __('Search') }} </x-primary-button></td>
            </tr></tbody></table>
        </form>
        </div></div>

        @if($all_posts->count() > 0)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
        <table><tbody>
        <tr>
            <th class="serial-id">#ID</th>
            <th>Title</th>
            <th>Posted By</th>
            <th>Date Created</th>
            @if($gen_helper::check_privillege("read_posts"))
            <th>Option</th>
            @endif
            @if($gen_helper::check_privillege("edit_posts"))
            <th>Details</th>
            @endif
            @if($gen_helper::check_privillege("delete_posts"))
            <th>Action</th>
            @endif
        </tr>
        @foreach($all_posts as $post)
        <tr>
            <td class="serial-id">{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->name }} <br> ({{ $post->email }})</td>
            <td>{{ $gen_helper::min_full_date($post->created_at) }}</td>
            @if($gen_helper::check_privillege("read_posts"))
            <td class="action"><a href="{{ url('admin/posts/view/' . $post->id) }}">View</a></td>
            @endif
            @if($gen_helper::check_privillege("edit_posts"))
            <td class="action"><a href="{{ url('admin/posts/edit/' . $post->id) }}">Edit</a></td>
            @endif
            @if($gen_helper::check_privillege("delete_posts"))
            <td class="action"><form action="{{ url('admin/posts/delete/' . $post->id) }}" method="post" onsubmit="javascript: return confirm('Are you sure you want to delete item #{{ $post->id }}?');">@csrf @method('DELETE') <button type="submit" style="color:#f11;">Delete</button></form></td>
            @endif
        </tr>
        @endforeach
        </tbody></table>

        @if($all_posts->hasPages())
        <div class="max-w-7xl mx-auto py-6 lg:py-8 bg-white mt-6 pagination"> {{ $all_posts->links() }} </div>
        @endif

        </div></div>
        @endif
                                                         
        </div>
    </div>
</x-admin-app-layout>
