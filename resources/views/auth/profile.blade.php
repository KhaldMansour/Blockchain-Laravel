@extends('layouts.app')

@section('content')
<div class="container">
<table class="table">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Handle</th>
      <th scope="col">Public Key</th>
      <th scope="col">Private Key</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>{{$user->public_key}}</td>
      <td>{{$user->private_key}}</td>

    </tr>
    <tr>
      <th scope="row">2</th>
      <td></td>
      <td></td>
      <td></td>
      <td>Don't share your private key with anyone</td>
    </tr>
  </tbody>
</table>

</div>
@endsection