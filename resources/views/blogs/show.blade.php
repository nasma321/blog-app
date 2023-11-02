@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <p style="display:none;"><?php echo $blog['id']; ?></p>
                <div class="card">
                    <div class="card-header">
                        <?php echo $blog['title']; ?>
                    </div>
                    <div class="card-body">
                        <?php echo $blog['content']; ?>
                    </div>
                    <div class="card-footer">
                        <button type="button" id="edit" class="btn btn-warning btn-sm" data-id="<?php echo $blog['id']; ?>">Edit</button>
                        <button type="button" id="delete" class="btn btn-danger btn-sm" data-id="<?php echo $blog['id']; ?>">Delete</button>
                    </div>
                </div>
        </div>
    </div>
</div>

<!-- boostrap model -->
<div class="modal fade" id="blogModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="blogModelTitle">Add Blog</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>            
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="editBlog" name="editBlog" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" rows="100" cols="80"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveBlog">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->

<script type="text/javascript">
    $(document).ready(function($){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#content').summernote({
            height: 450,
        });

        $('body').on('click', '#edit', function () {
            var id = $(this).data('id'); 

            $.ajax({
                type:"GET",
                url: "{{ route('blogs.show', ':id') }}".replace(':id', id),
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#blogModelTitle').html("Edit Blog");
                    $('#blogModel').modal('show');
                    $('#id').val(res.id);
                    $('#title').val(res.title);
                    $('#content').summernote('code', res.content);
                }
            });
        });

        $('body').on('click', '#delete', function () {
            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id'); 
                $.ajax({
                    type:"DELETE",
                    url: "{{ route('blogs.show', ':id') }}".replace(':id', id),
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection
