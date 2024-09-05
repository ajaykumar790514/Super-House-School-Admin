<form action="<?=base_url();?>importStockdata" method="post" enctype="multipart/form-data">
        <label for="file">Choose Excel File:</label>
        <input type="file" name="import_file" id="file" accept=".csv, .xls, .xlsx" required>
        <br>
        <input type="submit" value="Upload">
    </form>