@foreach ($comments as $item)
<div class="single-comment">                
    <div class="content">
        <h4> <img src="https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png" width="30px" alt="#"> {{ $item->name }}</h4>
        <p>  {{ $item->created_at }}</p>
        <br>
        <p>- {{ $item->comment }}</p>
        <br>
    </div>
</div>
@endforeach