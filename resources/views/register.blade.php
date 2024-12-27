@extends('layouts.app')
@section("title")
    Halaman Utama
@endsection
@section("content")
<main>
    <div class="container">
    <h1>Buat Akun Baru!</h1>
    <h2>Isilah form dibawah ini</h2>
    <form class="form" action="/send" method="POST" >
    @csrf
        <label for="firstName">First Name :</label>
        <input type="text" id="firstName" name="firstName">
        <br />  <br />
        
        <label for="lastName">Last Name :</label>
        <input type="text" id="lastName" name="lastName">
        <br />  <br />
        
        <label>Gender :</label> <br>
        <input type="checkbox" id="male" name="gender" value="male">
        <label for="male">Male</label> <br>
        <input type="checkbox" id="female" name="gender" value="female">
        <label for="female">Female</label> <br>
        <input type="checkbox" id="other" name="gender" value="other">
        <label for="other">Other</label> <br>
        <br />  <br />
        
        <label for="nationality">Nationality :</label> <br> <br>
        <select id="nationality" name="nationality">
            <option value="indonesian">Indonesian</option>
            <option value="india">English</option>
            <option value="india">Arabic</option>
            <option value="india">Japanese</option>
        </select>
        <br />  <br />
        
        
        <label>Language Spoken:</label> <br> <br>
        <input type="checkbox" id="male" name="language" value="male">
        <label for="maleLang">Male</label> <br>
        <input type="checkbox" id="female" name="language" value="female">
        <label for="femaleLang">Female</label> <br>
        <input type="checkbox" id="other" name="language" value="other">
        <label for="otherLang">Other</label> <br>
        <br />  <br />
        
        <label for="biodata">Bio :</label> <br> <br>
        <textarea id="biodata" name="biodata" rows="10" cols="30"></textarea>
        <br />  <br />
        
        <input type="submit" value="sign up">
    </form>
    
    </div>
</main>

@endsection   
