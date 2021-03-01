<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="layout/css/master.css?version=1.3.8">
    <link rel="stylesheet" href="layout/css/main.css?version=1.2.2">
    <link rel="stylesheet" href="layout/css/audio.css?version=1.1">
    <link rel="stylesheet" href="layout/css/icons.css?version=1.1.1">
    <script src="layout/javascript/elementController.js"></script>
    <script src="https://kit.fontawesome.com/98d3e6df54.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <title><?= $this->title // FROM RENDER  ?></title>
</head>
<body>
    
    <!--
        Root page
    -->
    <div class="root flex-r">
        <!-- 
            Head
        -->
        <div class="flex justify-spacebetween main-padding main-bottom-margin main-bottom-border">
            <h2>Wrispe</h2>
            <div class="flex-r justify-center align-i-end pointer">
                <div class="toggle-navbar-normal"></div>
                <div class="toggle-navbar-center"></div>
                <div class="toggle-navbar-normal"></div>
            </div>
        </div>

        {{content}}
        
    </div>




    <!--
        Bottom bar
    -->
    <div id="bottombar" class="flex justify-spacebetween navbar padding-all-15px">

        <div class="flex justify-center align-i-center btn-holder pointer">
            <i class="fas fa-stream i-m"></i>
            Feed
        </div>

        <div id="newPost" class="flex justify-center align-i-center btn-holder not-Selected pointer">
            <i class="fas fa-plus i-m i-black-color"></i>
            New
        </div>

        <!-- <div class="flex justify-center align-i-center btn-holder not-Selected">
            <i class="far fa-user i-m i-black-color"></i>
            Profile
        </div> -->

    </div>


    <!-- Player -->
    <div id="player" class="flex navbar hidden">
        <div class="audio-player">
            <div class="timeline">
                <div class="progress"></div>
            </div>
            <div class="controls">
                <div class="play-container">
                    <div class="toggle-play play"></div>
                </div>
                <div class="time">
                <div class="current" style="color:white">0:00</div>
                <div class="divider" style="color: white;">/</div>
                <div class="length" style="color: white;"></div>
            </div>
            <div id="storyTitle" class="name" style="color: white;"></div>
            <div id="ClosePlayer" style="color: white;">Close</div>
            </div>
        </div>
    </div>

    <!-- Factory -->
    <div id="factory" class="flex overlay justify-center align-i-center hidden">
        <div class="flex-r w80 whitebg">
            <p class="margin-b5 align-s-center">Create a new Wrispe</p>
            <p id="errorHolder" class="p-2 margin-b5 w80 flex align-s-center"></p>
            <div class="flex-r margin-b5 w80 align-s-center">
                <p class="p-15 margin-b2">Title</p>
                <input id="factoryTitle" dir="auto" class="inp" type="text" name="title" placeholder="Enter your story title" autocomplete="off" >
            </div>
            <div class="flex-r margin-b10 w80 align-s-center">
                <p class="p-15 margin-b2">Your Story</p>
                <textarea id="factoryContext" maxlength="4126" dir="auto" class="inp p-15" name="context" placeholder="What is on your mind? (4096 character limit)"></textarea>
            </div>
            <div class="flex justify-end w80 align-s-center margin-b5">
                <div id="cancelFactory" class="flex justify-center m-button warnColor">Cancel</div>
                <div id="startFactory" class="flex justify-center m-button okayColor margin-l5">Share</div>
            </div>
        </div>
    </div>

    <div id="loader" class="loader weight-700 flex justify-center align-i-center hidden">
        Loading this awesome story...
    </div>
    <script src="layout/javascript/loader.js"></script>
    <script src="layout/javascript/Factory.js?version=1.2"></script>
    <script src="layout/javascript/audioPlayer.js?version=1.1"></script>
    <script>
        
        $(document).on('click','#newPost',()=>{
            removeClass([document.getElementById('factory')]);
        })
        
        $(document).on('click','#cancelFactory',()=>{
            addClass([document.getElementById('factory')])
        })

        $(document).on('click','#startFactory',()=>{
            load();
            factoryPost = new postFactory();
            if(factoryPost.validate())
            {
                factoryPost.sendStory();
            }
            else{
                factoryPost.showError();
                stoploading();
            }

        })

        $(document).on('click','#postContainer',function(){
            Player.mount(this.dataset.file,this.dataset.title);
        })

        $(document).on('click','#ClosePlayer',()=>{
            Player.hidePlayer();
        })

    </script>
</body>
</html>