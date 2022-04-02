@extends('layouts.app')

@section('content')


    <div class="container">

    @if(session()->has('message'))
        <div class="alert alert-info">
            <a class="close" data-dismiss="alert">×</a>
            <strong>Heads Up!</strong> {!!Session::get('message')!!}
        </div>
    @endif

    <form name="add-transaction" method="POST" action="transactions/add-transaction" >
        @csrf
        
        <label for="from">From</label>
        <textarea id="from" name="from" type="text" class="form-control" placeholder="Enter your public key"></textarea>

        <label for="amount">Amount</label>
        <input id="amount" name="amount" type="text" class="form-control" placeholder="Type amount">

        <label for="to">To</label>
        <input id="to" name="to" type="text" class="form-control" placeholder="Type an address">

        <input id="tos" name="tos" type="hidden" class="form-control" placeholder="Type an address">

        <button type="button" name="button" class="btn btn-primary form-control" onclick="addAddress()">Add Address</button>


        <label for="private_key">Private Key</label>
        <textarea id="private_key" name="private_key" type="text" class="form-control" placeholder="Don't share your private key with anyone"></textarea>

        <button id="execute-button" type="submit" class="btn btn-primary submit" disabled> Execute Transactions </button>
    </form>

    <h3>Addresses<h3>
    <ul class="addresses" > </ul>

    <h3>Amount shared between transactions<h3>
    <h1 id ="amount-shared" class="amount-shared"> </h1>



    @section('scripts')
        <script type="application/javascript">
            console.log("here")

            var tos =[];

            var amount;

            var from;

            var private_key;

            function addAddress()
            {
                tos.push(document.getElementById('to').value);
                
                document.getElementById('tos').value = JSON.stringify(tos);
                
                $.trim($("#to").val());

                 if(tos.length > 0){
                    $("#execute-button").removeAttr('disabled');
                }

                $( ".addresses" ).append(
                    '<li>' + tos[tos.length - 1] + '</li>'
                )

                amount = document.getElementById('amount').value / (tos.length);
        
                document.getElementById('amount-shared').innerHTML = (amount);


                    
                // console.log( {{ auth()->user()->name }});
                // console.log( $("#tos").val() , JSON.stringify(tos))
                // amount = $.trim( $("#amount").val()) / (tos.length);

                // $( ".addresses" ).append(
                // '<li>' + tos[tos.length - 1] + '</li>')
            
                // $(".amount-shared").text(amount);
            }


            // $('form[name="add-transaction"]').submit(function(e){

            // e.preventDefault();

            // if ($.trim($("#amount").val()) === "") {
            //     alert('Please enter amount.');
            //     return false;
            //  }; 

            //  if ($.trim($("#from").val()) === "") {
            //     alert('Please enter your public key.');
            //     return false;
            //  }; 

            //  if ($.trim($("#private_key").val()) === "") {
            //     alert('Please enter your private key.');
            //     return false;
            //  }; 

            //  if ($.trim($("#to").val()) === "") {
            //     alert('Please enter address.');
            //     return false;
            //  }; 

            // tos.push($.trim($("#to").val()));

            // amount = $.trim( $("#amount").val()) / (tos.length);

            // from = $.trim( $("#from").val())

            // private_key = $.trim( $("#private_key").val())
            
            // $("#to").val('');

            // $( ".addresses" ).append(
            //     '<li>' + tos[tos.length - 1] + '</li>'
            // )
      
            // $(".amount-shared").text(amount);

            // if(tos.length > 0){
            //         $("#execute-button").removeAttr('disabled');
            //     }

            //     // console.log({!! json_encode((array)auth()->user()) !!});

            // });


            // $('form[name="execute-transactions"]').submit(function(e){

            //     let url = $(this).attr('action');

            //     // e.preventDefault();

            //     console.log(this);


            //     $.ajax({
            //         url: url,
            //         type:'POST',
            //         datatype:'json',
            //         contentType: "application/x-www-form-urlencoded",

            //         data:   
            //         {
            //         '_token': '{{csrf_token()}}',
            //         'from': from,
            //         'amount': amount,
            //         'to': JSON.stringify(tos),
            //         'private_key':private_key,
            //          'user' : {!! auth()->user() !!}
            //         },
            //         success: function (data) {
            //             console.log('Submission was successful.');
            //             console.log(data);
            //         },
            //         error: function (data) {
            //             console.log('An error occurred.');
            //             console.log(data);
            //         },
            //     });
            // });

        </script>
    @endsection
    </div>
@endsection
