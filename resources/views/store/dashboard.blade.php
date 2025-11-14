@extends('store.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <?php $user = auth()->user(); ?>
    <h3>Welcome, <?php echo $user->name ?>!</h3>
    <?php //echo '<pre>'; print_r($user); echo '</pre>'; ?>
    <p>Your admin dashboard is ready.</p>
    
    
@endsection
