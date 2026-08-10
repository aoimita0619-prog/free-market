@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('content')
<form action="{{ route('purchase.checkout', $item) }}" method="POST">
    @csrf

<div class="content">
    <div class="column__info">
      <div class="item-info__area">
        <div class="item-img__area">
          <img src="{{ $item->img ? asset('storage/' . $item->img) : '' }}" class="item__img">
        </div>
        <div class="item-info__purchase">
          <p class="item__name">{{ $item->name }}</p>
          <p class="item__price">￥{{ $item->price }}（税込）</p>
        </div>
      </div>

      <hr>
   
      <h2>支払方法</h2>
        <select name="method" id="method" >
            <option value="" disabled selected>選択してください</option>
            <option value="1" {{ old('method') == 1 ? 'selected' : '' }} required>コンビニ支払い</option>
            <option value="2" {{ old('method') == 2 ? 'selected' : '' }}>カード払い</option>
        </select>
      @error('method')
             <p class="error">{{ $message }}</p>
      @enderror
    
      
      <hr>
     
      <div class="address__header">
        <h2>配送先</h2>
        <a href="{{ route('purchase.address.edit', $item) }}">変更する</a>
      </div>
       <div class="user__address">
         <p>〒{{ $address['post_code'] }}</p>
         <span>{{ $address['address'] }}</span>
         <span>{{ $address['building'] }}</span>
       </div>
      
      

    </div>

  
    <div class="column__purchase">
      <table>
        <tr>
         <td>商品代金</td>
         <td>￥{{ $item->price }}</td>
        </tr>
        <tr>
          <td>支払方法</td>
          <td id="method_display">選択してください</td>
          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const paymentSelect = document.getElementById('method');
              const paymentDisplay = document.getElementById('method_display');

              paymentSelect.addEventListener('change', function () {
              paymentDisplay.textContent = this.options[this.selectedIndex].text;
              });
            });
          </script>
        </tr>
      </table>
    
      <button type="submit">購入する</button>
     
    </div>
</div>
</form>

<script src="https://js.stripe.com/v3/"></script>

<script>
const methodSelect = document.getElementById('method');
const cardArea = document.getElementById('card-area');

methodSelect.addEventListener('change', function(){

    if(this.value === "2"){
        cardArea.style.display = "block";
    }else{
        cardArea.style.display = "none";
    }

});

document.addEventListener('DOMContentLoaded', function () {
  const stripe = Stripe(
    "{{ config('services.stripe.key') }}"
  );


  card.mount('#card-element');
  const form = document.getElementById('purchase-form');


  form.addEventListener('submit', async function(e){
    e.preventDefault();


    const method = document.getElementById('method').value;


    // カード払いの場合
    if(method === "2"){
    
        const response = await fetch(
            {
                method: "POST",
                headers:{
                    "X-CSRF-TOKEN":
                    "{{ csrf_token() }}"
                }
            }
        );


        const data = await response.json();



        if(result.error){

            document.getElementById('card-errors')
            .textContent = result.error.message;

            return;

        }


        // Stripe成功
        form.submit();


    } else {

        // コンビニ払いはそのまま送信
        form.submit();

    }

});
});
</script>

@endsection