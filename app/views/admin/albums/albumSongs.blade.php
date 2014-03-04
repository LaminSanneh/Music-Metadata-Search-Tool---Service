@extends('admin.layouts.default')

@section('body')

<p>back to {{link_to_route('admin.artistAlbums', $album->artist->name, array($album->artist->id))}}</p>
<h2>Songs for album <strong>{{$album->name}}</strong> {{link_to_route('admin.newAlbumSong', '+Add Song', array($album->id), array('class' => 'btn btn-success'))}}</h2>
<table class="table table-striped">
    <tr>
        <th>
            Song Name
        </th>
        <th>

        </th>
    </tr>
    @foreach($album->songs as $song)
    <tr>
        <td>
            {{$song->name}}
        </td>
        <td>
            {{link_to_route('admin.deleteSong','Delete',array($song->id), array('class' => 'btn btn-danger'))}}
        </td>
    </tr>
    @endforeach
</table>

@stop