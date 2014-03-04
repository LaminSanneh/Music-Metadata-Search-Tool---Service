@extends('admin.layouts.default')

@section('body')

<h2>Artists {{link_to_route('admin.newArtist', '+New Artist', null, array('class' => 'btn btn-success'))}}</h2>
<table class="table table-striped">
    <tr>
        <th>
            Artist Name
        </th>
        <th>

        </th>
        <th>

        </th>
    </tr>
    @foreach($artists as $artist)
        <tr>
            <td>
                {{ link_to_route('admin.artistAlbums',$artist->name, array($artist->id)) }}
            </td>
            <td>
                {{ link_to_route('admin.editArtist','Edit', array($artist->id), array('class' => 'btn btn-primary')) }}
            </td>
            <td>
                {{link_to_route('admin.deleteArtist', 'Delete', array($artist->id), array('class' => 'btn btn-danger'))}}
            </td>
        </tr>
    @endforeach
</table>

@stop