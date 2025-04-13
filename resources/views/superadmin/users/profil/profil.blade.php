<div class="row">

    <div class="col-lg-4">
        <x-form-input label="Nama" value="" type="text" name="name" id="name" class="name" list-option="" :label-required="true"></x-form-input>
    </div>

    <div class="col-lg-4">
        <x-form-input label="Telepon" value="" type="number" name="telepon" id="telepon" class="telepon" list-option="" :label-required="true"></x-form-input>
    </div>

    <div class="col-lg-4">
        <x-form-input label="E-mail" value="" type="text" name="email" id="email" class="email" list-option="" :label-required="true"></x-form-input>
    </div>
</div>

<div class="row mt-3">
    <div class="col">
        <button onclick="submitForm(this.form, this)" class="btn btn-primary">Simpan</button>
    </div>
</div>
