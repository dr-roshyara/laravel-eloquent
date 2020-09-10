## ELOQUENT RELATIONSHIP 
This series is based on the tutorial of Laracasts video seris. 
I am learning now **Laravel Eleqoent** . This series has 5 videos. 
# First video: one note one relationship 
    #settings    
    #install laravel 
    #Install the following ppackage 
    composer require "laracasts/generators" --dev
    #Install laravel testdummy 
    composer  require laracasts/testdummy  --dev
    #run the follwoing commands 
    npm install 
    npm run dev     
#   #
    Open the config/app.php file and add        
    Laracasts\Generators\GeneratorsServiceProder::class, 
    #Create a migration for post using the following command 
       php artisan make:migration:schema create_posts_table --schema="user_id:integer:foreign, title:string,body:text"
    #This command builds the schema automatically. Howeever we need to edit the migration_post table as following 
      Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });
#    #Set up the datbank 
     Go to the .env file 
     create  necessary database and login  data 
    #Run the migrate command to migrate the tables 
        php artisan migrate 
#    #How to use the db:seed command 
     - #use db:seed e.g. in posts table 
        php artisan db:seed posts 
    - #Editthe seeder files lying on the seeds directory    
      #add on the post seeds like : 
        TestDummy::times(50)->create('App\Post');
    - #add the in the main databaseSeeder.php file  also like following 
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(PostsTableSeeder::class);
    }
    #Create a factory for the Post 
    for this use the following command 
      php artisan make:factory PostFactory --model Post 
    #factory post : 
        <?php
        /** @var \Illuminate\Database\Eloquent\Factory $factory */
        use App\User;
        use App\Post;
        use Faker\Generator as Faker;

        $factory->define(Post::class, function (Faker $faker) {
            return [
                //
                'user_id'=> factory(App\User::class),
                // 'user_id'=> App\User::all()->random(),
                'title'=>$faker->sentence,
                'body'=>$faker->paragraph,


            ]; 
        });

    #After creating a factory for post and User. see database\factories 
   #add data to Database 
    #Run  the following command again 
        php artisan db:seed 
    #This command will create dummy datasets 
#    #Alterative way to populate database 
      #open tinker 
        php artisan tinker  
        factory(App\Post::class,1)->create() // this will create 1 
        factory(App\Post::class,100)->create() // this will create 100  
    #create a Comment Model and table etc 
        php artisan make:model Tag -ar 
    # Create a resourceful Tag table 
        php artisan make:model Tag  -ar 
# Many to Many relationship 
    # Create a post_tag table 
        php artisan make:migration create_post_tag_table --create=post_tag
    #EDit the post_tag table as folllowing 
        public function up()
         {
         Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('tag_id');

            $table->timestamps();
        });
    }
#    #create the relationship with attach and detach method 
    #Use the following commands 
       php artisan tinker 
       $tag =App\Tag::find(1)
    //Attach this tag to post with post id =10 
      $tag->posts()->attach(10)
      $post =App\Post::where('id', '=', 100)
    //attach the tag with id of 1 with this post 
    $post->tags->attach(1)
    //look at the post 
      $post->tags 
       exit 
 #   #04-09.2020 : 
    #User some more php artisan tinker command 
         php artisan tinker 
        factory(APP\Post::class)->create(['user_id'=>2])
        factory(App\Post::class)->create(['title'=>"second Title"])

#    #Define the user relationship with post 
        public function posts(){
                return $this->hasMany(Post::class);
        }
        $post =App\Post::find(3)
        $post->user 
        #By writing the elequent relationship you can write either default 
			▪ return $this->belongsTo(User::class); // default is 'user_id' or 
			▪ you an specifiy yourself return $this->belongsTo(User::class, 'person_id'); // user_id is specified as 'person_id' 
    # Check it in php tinker 
				□ php artisan tinker 
				□ $article=App\Article::find(5) // 5 is the id of the article 
				□ $article->tags->attach(1) // this  will attach tag 1  with article 5. 
				□ $article->tags->attach([1,2,4]) // three tags were attached 
				□ Now check the linking table of many to many relationship 
				□ $article->tags->dettach([1,2,4]) // you can also deatch the tags 
                You can use withTimestamps () or not 
    #Alternative way to sae the relationsihp 
        $user =User::first(); 
        $article =Article::first() 
        $user->aricle()->save($article, ['title'=>'some title']);

	#In order to debug laravel, there is a package called laravel debuger . Use this package to debuag . 
	    https://github.com/barryvdh/laravel-debugbar
		composer require barryvdh/laravel-debugbar --dev
 #  #Example for the relationship    between users and contacts 
     #User: 
        class User extends Model {
         public function  contacts(){
             return $this->belongsToMany(Contact::classs)
         }

     }
     #Contact 
     class Contact extends Model {
         public function  users(){
             return $this->belongsToMany(User::classs)
         }

     }
# Has many through relationship :
    #example of relationship:  
        authors -> affiliatons->posts 
        customers -> contacts-> telephone numbers 
        
    #Aim: 
    #WE have  1. users or writers . They have different affiliation: e.g. left , right, conservative etc.  and then we have posts . These posts are written by the authors or users who have some kind of affiliation. 
    #Now we would like to find out a relationship between the post and affiliation through the users.
    #Find all the posts which have an affiliation "conservative" . 
    #For this we do the following stuffs: 
#   #create a model 
    php artisan make:model  Affiliation -m -f 
    #-m means migration 
    #-f means factory 
#   #Edit the table 
#   #Edit the factories 
    # while creating factory for user, we can use the  affiliation factory in user factory so that it automatically creates the affiliations . 
    #Look at the user factory file and understand the following  code : 
    $factory->define(User::class, function (Faker $faker) { 
    return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'affiliation_id'=>function (){
                return factory(App\Affiliation::class)->create()->id;
            }
        ];
    });
   #Use the folloiwng command to  create users 
   factory(App\user::class ,10)->create()
   //the follwoing command creates 10 user with affiliation id=3 
   factory(App\User::class, 10)->create(['affiliation_id'=>3])
#   #Understand the Has many through relationship 
    #make queeries in your datenbank 
     #find all users with afffiliation id =1 
    - SELECT * FROM users WHERE affiliation_id=2;
    #find all users with afffiliation id =2 
    - SELECT * FROM users WHERE affiliation_id=1;
    - select id form user where affiliation_id=1
    - SELECT id FROM users WHERE affiliation_id=2;
    - SELECT * FROM posts WHERE user_id IN (1,4);
#    #Define hasManyThrough relationsip 
      //App\Affiliation.php 
      <?php
        namespace App;
        use App\User;
        use App\Post;
        use Illuminate\Database\Eloquent\Model;

        class Affiliation extends Model
        {
            //
            public function posts (){
                return $this->hasManyThrough(Post::class, User::class);
            }
        }
   #Similarly you can also define the  phonenumber of a user as follownig 
    class User extends Model {
        public function phoneNumbers(){
            return $this->hasManyThrough(PhoneNumber::class,Contact::class);
        }
    }
    #understand like this: User has many contacts and each contact has many phone numbers. Now  we want to derive all the phone numbers that are associated with a user. 
#   #Has one thruogh relationship 
    You can also define in the same way has also one through relationship .     

# Polymorphic Relationsip 
    #example:
        videos bleongs  at some time to a series 
        same videos belongs at other time to a collections  of videos 
        So videos can be described by a property called watchable. It  can be defiend as morphs('watchable') property and 
        #this property creates two  columns:
        watchable_id and watchable_type . 
    #another example 
        #We have four models: User, Star, Contact and Event. the contacts and events are related to the users as many to many relationshp and has Many through relationship with users->contacts->events 
        #however we still have stars each star is a like or dislike. That star can be defined as starrable property of contacts and events because a user can like a contact and an event. 
        #So stars contain starrable_id and starrable_type fields. 

    #create a Video model 
        php artisan make:model Video -m -f 
    #This commands create  migration -m option and factory with -f option . 
#   #create the migration table 
    #Edit the migration table of video as following : 
        public function up()
        {
            Schema::create('videos', function (Blueprint $table) {
                $table->id();
                $table->morphs('watchable');
                $table->string('title');
                $table->text('description');
                $table->string('url');
                $table->timestamps();
            });
        }
        #video has two columns then watchable_id and watchable_type 
        watachable_Type :  App\Series or App\Collection; 
        watchable id  : represents the video id of Seris or  video_id in the Collection based on its type.  
        #Make another model for series 
        php artisan make:model Series -f -m 
        public function up()
        {
            Schema::create('series', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('desription');            
                $table->timestamps();
            });
        }
        #make collection model 
        php artisan make:model collections -f -m 
        public function up()
        {
            Schema::create('collections', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }
#   # Define the relationship . 
    #Series  Model is defined as following: 
         <?php

        namespace App;
        use App\videos;

        use Illuminate\Database\Eloquent\Model; 
        use App\Video;
        class Series extends Model
        {
            //
            public function videos(){
                    return $this->morphMany(Video::class, 'watchable'); 
            }
        }
    #Collection Model is define as follwoing : 
     <?php

        namespace App;

        use Illuminate\Database\Eloquent\Model;

        class Collection extends Model
        {
            //
            public function videos(){
                return $this->morphMany(Video::class, 'watchable'); 
        }
        }
    #video Model is defined as following 
        <?php

        namespace App;
        use Illuminate\Database\Eloquent\Model;

        class Video extends Model
        {
            // 
            public function watchable(){  
                return $this->morphTo( );
            }

        }
#   #Check the relationship with tinker 
    php artisan tinker 
    $series =App\Series::first()
    $collection=App\Collection::first();
    $series->videos 
    $collection->videos
    #important thing is that you have to define the watchable_type as the model : i.e. 
     watchable_type= App\Series 
     or 
     watchable_type= App\Collection 
#    #reverse relationship. vidoe->collection or video->series 
    $video =App\Video::first()
    $video->watchable  // this gives the  name of the model with which it is associated. 
#   #Define the watchable property in other way. 
    class Video extends Model
        {
            // 
            public function parent(){  
                return $this->morphTo( 'watchable');
            }
        }
    # then you can get the relationship as following 
    $video =App\Video::first()
    $video->parent  // this gives the  name of the model with which it is associated. 
#   #Define Watchable_type 
    #Watchable_tpye must contain the Model name like App\Series or App\Collection 
    #However we can give them as normal name by defining them in AppServiceproviders. 
    - Go to AppServiceProvider 
    -Edit it as following 
    <?php

        namespace App\Providers;

        use Illuminate\Support\ServiceProvider;
        use Illuminate\Database\Eloquent\Relations\Relation;
        class AppServiceProvider extends ServiceProvider
        {
            /**
            * Register any application services.
            *
            * @return void
            */
            public function register()
            {
                //
            }

            /**
            * Bootstrap any application services.
            *
            * @return void
            */
            public function boot()
            {
                //
                Relation::morphMap([
                    'series'=>'App\Series',
                    'collection'=>'App\Collection'
                
                ]);

            }
        }

    #Now you can write in the database the watchable propery : 
    watchable_type ='series' 
    or 
    watchable_type ='collection'
# Many to Many Polymorphic relationship 



