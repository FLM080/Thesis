<x-layout>
    <div>
        <h1>Profile Page</h1>
        <p>Name: {{ auth()->user()->name }}</p>
        <p>Email: {{ auth()->user()->email }}</p>
    </div>
</x-layout>