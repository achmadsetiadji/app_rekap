<x-modal size="modal-md">
  <x-slot name="title"></x-slot>
  @method('post')

  <x-form-input label="Name" value="" type="text" name="name" id="name" class="name"
      list-option="" :label-required="true"></x-form-input>

  @php
      $category = ['' => 'Select Category', 'lifestyle' => 'Lifestyle', 'workout' => 'Workout', 'diet' => 'Diet'];
  @endphp
  <x-form-input label="Category" type="select" name="category" id="category" class="category" :list-option="$category"
      :label-required="true"></x-form-input>
      
  <x-form-input label="Description" value="" type="textarea" name="description" id="description" class="description"
      list-option="" :label-required="true"></x-form-input>  

  <x-form-input label="Thumbnail" value="" type="upload_file" name="thumbnail" id="thumbnail" class="thumbnail"
      list-option="" :label-required="true"></x-form-input>

  <x-slot name="footer">
      <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
      <button id="button-submit" class="btn btn-primary" onclick="submitForm(this.form, this)">Save</button>
  </x-slot>
</x-modal>
