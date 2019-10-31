<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Tasks</title>
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="{{ url('js/moment.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>

  <div class="container">
  <div class="row">
    <div class="col-md-3">
      @if ($errors->any() )
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

      <form action="{{ route('addTask') }}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
          <label for="title">სათაური</label>
          <input type="title" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="date">თარიღი</label>
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' class="form-control" name="date" required />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="form-group">
          <label for="files">ფაილები</label>
          <input type="file" name="files[]" multiple>
        </div>
        <button type="submit" class="btn btn-primary">დამატება</button>
        </form>
    </div>

    <div class="col-md-3">
      <label>დავალებები</label>
        <ul class="list-group">
      @forelse($tasks as $task )
      @php
      $files = $task->files;
      @endphp
        <li class="list-group-item">
          {{  $task->title }}

          <a class="pull-right" href="{{ route('deleteTask',['task_id' => $task->id ]) }}">
             <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
          </a>
          <span class="label label-info pull-right">{{  $task->date }}</span>
          <ul>
            @forelse($files as $file)
              <li class="list-group-item">
                <a href="{{ $file->getPath() }}" download="{{ $file->name }}">
                  {{ $file->original_name }}
                  <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </a>
                <a href="{{ route('deleteFile',['task_id' => $task->id,'file_id' => $file->id ] ) }}">
                   <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
              </li>
            @empty
            ფაილები არ არის
            @endforelse`
          </ul>


        </li>

      @empty
      დავალებები არ არის
      @endforelse
      </ul>
    </div>

  </div>
</div>

<script type="text/javascript">

    $(function () {

        $('#datetimepicker1').datetimepicker({
            // format: 'dddd, MMMM Do YYYY, h a',
            // format: 'YYYY-MM-DD H:00:00',
            // format: 'YYYY-MM-DD',
            format: 'DD-MM-YYYY',
            // format: 'dd-mm-yyyy',
            minDate: new Date(),
            // minDate: dateToday,
            // format: 'LT'
        });
    });

</script>
</body>
</html>
