<!DOCTYPE html>
<html>
    <head>
        <title>Company Info Scraper</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <section class="title mt-3"> 
                <h1 class="title">Company Info Scraper</h1>
            </section>


            <section class="add-new-section mt-3"> 
                <h3>Add New Company</h3> 

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="/add" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="url">Enter the URL of Company Master Detail Page:</label>
                        <input type="text" class="form-control" id="url" placeholder="Enter URL" name="url" value="{{ old('url') }}" required>
                        @error('url')
                            <p class="text-danger"><small>{{$errors->first('url')}}</small></p>
                        @enderror
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </section>

            <section class="list-companies mt-3">
                <h3>List of Company</h3> 
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">CIN</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Class</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = $companies->firstItem();
                        @endphp
                        @foreach($companies as $key => $company)
                            <tr>
                                <td scope="row">{{ $i + $key }}</td>
                                <td>{{ $company->cin }}</td>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->class_company }}</td>
                                <td>{{ $company->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $companies->links() }}               
            </section>

        </div>

    </body>
</html>