<?php

namespace kiwi\Http;

use kiwi\Database\Post;
use kiwi\Http\Middleware\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;

    /**
     * Render the index page.
     *
     * @return void
     */
    public function index()
    {
        View::renderAdminView('index', ['posts' => Post::all()]);
    }

    /**
     * Render the write page.
     *
     * @return void
     */
    public function create()
    {
        View::renderAdminView('create');
    }

    /**
     * Store a post in the database.
     *
     * @return void
     */
    public function store()
    {
        $post = new Post();

        $post->title = Input::field(
            'title',
            [
                'required' => 'The title is required.',
                'min:3'    => 'The title needs to be atleast 3 characters long.',
            ]
        );

        $post->body = Input::field(
            'body',
            [
                'required' => 'The body field is required.',
                'min:5'    => 'The body needs to be atleast 5 characters long.',
            ]
        );

        $post->save();

        Request::redirect('/admin');
    }

    /**
     * Delete a post.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        $post = new Post($id);
        $post->delete();

        Request::redirect('/admin');
    }

    /**
     * Show the form for editing a post.
     *
     * @param Post $post
     *
     * @return void
     */
    public function edit(Post $post)
    {
        View::RenderAdminView('edit', ['post' => $post]);
    }

    /**
     * Update a post.
     *
     * @param Post $post
     *
     * @return void
     */
    public function update(Post $post)
    {
        $post->title = Input::field(
            'title',
            [
                'required' => 'The title is required.',
                'min:3'    => 'The title need to be atleast 3 characters long.',
            ]
        );

        $post->body = Input::field(
            'body',
            [
                'required' => 'The body field is required.',
                'min:5'    => 'The body needs to be atleast 5 characters long.',
            ]
        );

        $post->update();

        Request::redirect('/admin');
    }
}
