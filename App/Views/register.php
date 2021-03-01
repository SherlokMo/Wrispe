<div class="flex-r align-i-center margin-b15">
    <h2>
        Sign up.
    </h2>    
    <p>
        start your journey!
    </p>
</div>


<p class="p-2 margin-b5 "> <?= $error ?? "" ?> </p>

<div class="flex-r">
    <form class="flex-r" method="POST" action="/register">
        <div class="flex-r margin-b5">
            <input class="input-trans-1" type="text" name="username" placeholder="Username, or email" autocomplete="off" >
        </div>
        <div class="flex-r margin-b5">
            <input class="input-trans-1" type="text" name="firstname" placeholder="Enter your First name" autocomplete="off" >
        </div>
        <div class="flex-r margin-b5">
            <input class="input-trans-1" type="text" name="lastname" placeholder="Enter your Last name" autocomplete="off" >
        </div>
        <div class="flex-r margin-b5">
            <input class="input-trans-1" type="email" name="email" placeholder="Enter your Email" autocomplete="off" >
        </div>
        <div class="flex-r margin-b15">
            <input class="input-trans-1" type="password" name="password" placeholder="Enter your Password" autocomplete="off" >
        </div>

        <div class="flex-r">
            <div class="flex align-s-center margin-b5 p-2">
                Already have an account? <a href="/login" class="weight-700 margin-l5"> Login</a>
            </div>
            <button type="submit" class="flex btn-large justify-center weight-700 pointer">Sign up</button>
        </div>

    </form>
</div>
