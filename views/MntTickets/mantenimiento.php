<div id="modalmantenimiento" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="ticket_form" autocomplete="off">
            <div class="modal-content shadow-lg">

                <!-- HEADER -->
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold" id="lbltitulo">Nuevo Ticket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <input type="hidden" id="ticket_id" name="ticket_id">

                    <div class="row g-3">

                        <!-- Titulo -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Título *</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>

                        <!-- Categoría -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Categoría *</label>
                            <select class="form-control" id="categoria" name="categoria" required>
                                <option value="">Seleccione</option>
                                <option value="Soporte">Soporte</option>
                                <option value="Sistema">Sistema</option>
                                <option value="Base de Datos">Base de Datos</option>
                                <option value="Redes">Redes</option>
                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark">Descripción *</label>
                            <textarea class="form-control" rows="5" id="descripcion" name="descripcion" required></textarea>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
