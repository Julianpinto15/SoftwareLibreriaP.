<p class="text-end py-4">
    <a href="#" class="btn btn-primary rounded-pill btn-back fs-5 fw-bold">
        <i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Regresar atrás
    </a>
</p>

<script type="text/javascript">
    let btn_back = document.querySelector(".btn-back");
    
    btn_back.addEventListener('click', function(e){
        e.preventDefault();
        window.history.back();
    });
</script>