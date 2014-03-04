@extends('admin.layouts.default')

@section('body')

<p>back to {{link_to_route('admin.artists','All Artists')}}</p>
<h2>Albums by <strong>{{$artist->name}}</strong> {{link_to_route('admin.newArtistAlbum', '+Add Album', array($artist->id), array('class' => 'btn btn-success'))}}</h2>
<table class="table table-striped">
    <tr>
        <th>
            Album Name
        </th>
        <th>
            Artist
        </th>
        <th>
            Release year
        </th>
        <th>
            Genre
        </th>
        <th>
            Notes
        </th>
        <th>
            Picture
        </th>
        <th>

        </th>
        <th>

        </th>
    </tr>
    @foreach($artist->albums as $album)
    <tr>
        <td>
            {{link_to_route('admin.albumDetails',$album->name, array($album->id)) }}
        </td>
        <td>
            {{$album->artist->name}}
        </td>
        <td>
            {{$album->release_year}}
        </td>
        <td>
            {{$album->genre}}
        </td>
        <td>
            {{$album->notes}}
        </td>
        <td>
            {{$album->picture}}
        </td>
        <td>
            {{link_to_route('admin.editAlbum', 'Edit', array($album->id), array('class' => 'btn btn-primary'))}}
        </td>
        <td>
            {{link_to_route('admin.deleteAlbum', 'Delete', array($album->id), array('class' => 'btn btn-danger'))}}
        </td>
    </tr>
    @endforeach
</table>

@stop