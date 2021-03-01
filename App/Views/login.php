<div class="flex-r align-i-center margin-b15">
    <h2>
        Let's sign you in.
    </h2>    
    <p>
        Welcome back.
    </p>
    <p>
        You've been missed!
    </p>
</div>

<p class="p-2 margin-b5 "> <?= $error ?? "" ?> </p>

<div class="flex-r">
    <form class="flex-r" method="POST" action="">
        <div class="flex-r margin-b5">
            <input class="input-trans-1" type="text" name="username" placeholder="Username, or email" autocomplete="off" >
        </div>
        <div class="flex-r margin-b15">
            <input class="input-trans-1" type="password" name="password" placeholder="Password" autocomplete="off" >
        </div>

        <div class="flex-r">
            <div class="flex align-s-center margin-b5 p-2">
                Don't have an account? <a href="/register" class="weight-700 margin-l5"> Register</a>
            </div>
            <button type="submit" class="flex btn-large justify-center weight-700 pointer">Sign in</button>
        </div>

    </form>
</div>


