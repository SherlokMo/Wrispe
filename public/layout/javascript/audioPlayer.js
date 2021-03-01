const audioPlayer = document.querySelector(".audio-player");
class aPlayer{


    constructor()
    {
        this.initVariables()
    }

    async newStory(name)
    {
        this.sound = new Audio("../runtime/audio/"+name);
        clearInterval(this.inter);
        this.sound.addEventListener(
            "loadeddata",
            () => {
              audioPlayer.querySelector(".time .length").textContent = getTimeCodeFromNum(
                this.sound.duration
              );
              this.sound.volume = 1;
            },
            false
          );
          this.setIner();    
          this.startNew();    

    }

    async mount(file,title)
    {
        load();
        addClass([this.bottomBar]);
        removeClass([this.soundWrapper]);
        await this.stopPrevious()
        await this.setTitle(title);
        await this.newStory(file)
        stoploading()
    }

    setTitle(title)
    {
        changeText(document.getElementById('storyTitle'),title)
    }

    startNew()
    {
        playBtn.classList.remove("play");
        playBtn.classList.add("pause");
        this.sound.play();
    }

    stopPrevious()
    {
        if(this.sound){
            playBtn.classList.remove("pause");
            playBtn.classList.add("play");
            this.sound.pause();
            this.sound.currentTime = 0;
        }
    }
    setIner()
    {
       this.inter =  setInterval(() => {
            const progressBar = audioPlayer.querySelector(".progress");
            progressBar.style.width = this.sound.currentTime / this.sound.duration * 100 + "%";
            audioPlayer.querySelector(".time .current").textContent = getTimeCodeFromNum(
              this.sound.currentTime
            );
          }, 500);
    }

    initVariables()
    {
        this.soundWrapper = document.getElementById('player');
        this.bottomBar = document.getElementById('bottombar');
        this.sound = null;
    }

    async hidePlayer()
    {
        load()
        await this.stopPrevious();
        removeClass([this.bottomBar]);
        addClass([this.soundWrapper]);
        stoploading();
    }

}

let Player = new aPlayer(); 

  
  //click on timeline to skip around
  const timeline = audioPlayer.querySelector(".timeline");
  timeline.addEventListener("click", e => {
    const timelineWidth = window.getComputedStyle(timeline).width;
    const timeToSeek = e.offsetX / parseInt(timelineWidth) * Player.sound.duration;
    Player.sound.currentTime = timeToSeek;
  }, false);
  
  
  
  //toggle between playing and pausing on button click
  const playBtn = audioPlayer.querySelector(".controls .toggle-play");
  playBtn.addEventListener(
    "click",
    () => {
      if (Player.sound.paused) {
        playBtn.classList.remove("play");
        playBtn.classList.add("pause");
        Player.sound.play();
      } else {
        playBtn.classList.remove("pause");
        playBtn.classList.add("play");
        Player.sound.pause();
      }
    },
    false
  );
  
  
  //turn 128 seconds into 2:08
  function getTimeCodeFromNum(num) {
    let seconds = parseInt(num);
    let minutes = parseInt(seconds / 60);
    seconds -= minutes * 60;
    const hours = parseInt(minutes / 60);
    minutes -= hours * 60;
  
    if (hours === 0) return `${minutes}:${String(seconds % 60).padStart(2, 0)}`;
    return `${String(hours).padStart(2, 0)}:${minutes}:${String(
      seconds % 60
    ).padStart(2, 0)}`;
  }
  