<template>
  <div class="datepicker-wrapper">
    <input
      type="text"
      :value="value"
      @input="$emit('input', $event.target.value)"
      class="datepicker"
      ref="input"
    />
  </div>
</template>

<script>
export default {
  name: 'DatePicker',
  props: {
    value: {
      type: String,
      default: ''
    }
  },
  mounted() {
    if (window.moment) {
      // Initialize flatpickr or other date picker library here
    }
  }
}
</script>
