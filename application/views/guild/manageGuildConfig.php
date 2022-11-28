<script>
    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("ddb");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
    }
</script>
<div class="row mt-3">
    <div class="col-12">
        <?php
        if (validation_errors() != null) {
            echo '<div class="alert alert-danger" role="alert">
            Le prefix doit être compris entre 1 et 5 caractères.
            </div></div><div class="row">';
        }
        echo form_open('configuration/'.$guild->id);
        echo "<span>Prefix : </span>";
        echo "<input maxlength=5 onkeyup='if (this.value != \"$prefix\") {show()} else {hide()}' style='background-color: #2A2D30; color: white;border: solid 1px;border-color:white; width: 70px' type='text' id='txtPrefix' name='txtPrefix' value='".$prefix."'>";
        ?>
    </div>
</div>


<!-- Fin des divs pour le panel module -->
</div>
</div>