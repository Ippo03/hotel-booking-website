<!-- This component represents a search container for the "Check Out" date input and arrows.
     Its appearance is adjusted based on the current page. -->
<div class="to-search flex-center orange-background <?php echo $currentFile === "list.php" ? "search-container search-container-width-list to-search-margin-list" : "to-search-margin-index"; ?>">
    <input id="dateOutInput" class="datepicker datepicker-out no-border orange-background" type="text" name="check_out_date" placeholder="Check Out">
    <div class="arrows check-out flex-align-center">
        <img src="../resources/assets/icons/left-arrow.png" class="left-arrow-out" alt="Left Arrow"/>
        <img src="../resources/assets/icons/right-arrow.png" class="right-arrow-out" alt="Right Arrow"/>
    </div>
</div>
