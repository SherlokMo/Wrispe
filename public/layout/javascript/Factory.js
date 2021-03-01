
class postFactory{


    constructor()
    {
        this.error = false;
        this.initElements()
    }

    validate()
    {
        if(this.title.length > 1 && this.title.length <= 64)
        {
            if(this.context.length>7 && this.context.length <= 4098){
                return true;
            }
            this.addError("Story should be between 8 characters and 4098 character.")
            return false;
        }
        this.addError("Title should be between 2 characters and 64 character.")
        return false;
    }

    async sendStory()
    {

        $.ajax({
            type:'POST',
            url:'/api/post',
            data:{
                title:this.title,
                context:this.context
            },
            dataType:"json"
        }).then((res)=>{
            console.log(res);
            if(res.ok)
            {
                window.location.replace("/");
                return true;
            }
            this.addError(res.message);
            this.showError();
            stoploading();
        });


    }

    initElements()
    {
        this.title = document.getElementById('factoryTitle').value;
        this.context = document.getElementById('factoryContext').value;
        this.errholder = document.getElementById('errorHolder');
        changeText(this.errholder,''); 
    }

    addError(error)
    {
        this.error = error;
    }

    showError(error)
    {
        changeText(this.errholder,this.error);
    }





}