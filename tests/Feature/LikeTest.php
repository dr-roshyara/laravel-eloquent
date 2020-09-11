<?php

namespace Tests\Feature;
use App\Post;
use App\User;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikePostsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
        // use RefreshDatabase;
      public function testA_post_can_be_liked(){
         $this->actingAs(factory(User::class)->create());
        $post =factory(Post::class)->create();
        //  $user =factory(User::class)->create();
        $post->like();
         
         $this->assertCount(1, $post->likes);
         $this->assertTrue($post->likes->contains('id', auth()->id()));
    }
    public function test_a_comment_can_be_liked(){
      $this->actingAs(factory(User::class)->create());
      // $post =factory(Post::class)->create();
      $comment =factory(Comment::class)->create();
      $comment->like();
      $this->assertCount(1,$comment->likes); 
    }
    
}
