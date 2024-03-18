{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}



<body>

 

    <div>
        <div style="text-align: center ; color : blue ;" 
        >   <img 
            style="width: 100px;"
        src="http://electronicplatform.senuusi.online/public/img/hero-1.png" class = "logo" alt="">  </div>
 
         <h2 style="text-align: center">  {{$title}}</h2>
        <div style="text-align: right">
            <a 
           
            >  {{$message}} </a>  
        </div>
    </div>
</body>

