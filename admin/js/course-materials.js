jQuery(document).ready(($) => {
  $("#ld_course_materials_shortcode").on("click", () => {
    const $shortcodeInput = $("#ld_course_materials_shortcode");
    $shortcodeInput.select();
    document.execCommand("copy");
    alert("Shortcode copied to clipboard!");
  });
});
