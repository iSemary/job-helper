<div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="openModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modalDialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="openTargetModal"></div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).on('click', '.open-modal-btn', function(e) {
            openModal($(this).attr('data-url'));
        });
        $("select.select2").select2({});
    </script>
@endpush
