@extends('layouts.app')

@section('content')

    <div class="col-md-10">
        <div class="view-container container">
            <h1>Amis</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Lien</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td><a href="#">Voir le profil</a></td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td><a href="#">Voir le profil</a></td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td><a href="#">Voir le profil</a></td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td><a href="#">Voir le profil</a></td>
                    </tr>
                </tbody>
            </table>
            <h1>Demandes en attente</h1>
            Encore un tableau ici...
            <h1>Demandes refusées</h1>
            Encore un tableau ici...
        </div>

    </div>

@endsection