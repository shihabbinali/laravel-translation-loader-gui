<a href="javascript:" data-toggle="modal" data-target="#exampleModal{{ $line->id . $lang }}">
    {{ $line->text[$lang] }}  <i class="ion-edit"></i>
</a>
<div class="modal fade" id="exampleModal{{ $line->id . $lang }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $line->key }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="form-group">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    <textarea class="form-control" id="trans{{ $lang }}{{ $line->id }}" name="trans">{{ $line->text[$lang] }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button"
                            onclick="controlTrans('{{ route('_translation-loader.update', $line) }}', '{{ $lang }}', '{{ $line->id }}')"
                            class="btn btn-primary"
                            data-dismiss="modal">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>