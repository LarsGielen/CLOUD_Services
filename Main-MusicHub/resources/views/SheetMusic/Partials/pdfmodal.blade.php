<x-modal name="getPDFModal" focusable onfocus="downloadPdf()">
    <div class="flex flex-col gap-4 items-center m-6">

        <x-primary-button id="linkButton" onclick="downloadPdf()">Start conversion</x-primary-button>

        <h1 id="linkText"></h1>
        <a href="" id="link" class="text-blue-500 hover:text-blue-800"></a>

        <x-secondary-button x-data="" x-on:click.prevent="$dispatch('close-modal', 'getPDFModal')">
            Cancel
        </x-secondary-button>        
    </div>
</x-modal>

<script type="text/javascript">
    function downloadPdf() {

        document.querySelector('#linkText').textContent = 'Please wait while the server generates the pdf file';
        document.querySelector('#linkButton').style.display = "none";

        fetch('/sheetmusic/pdf/{{ $SheetMusic->id }}')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(json => {
            console.log(json.link);
            document.querySelector('#link').href = json.link;
            document.querySelector('#link').textContent = 'Link to PDF';
            document.querySelector('#linkText').textContent = 'Please wait while the server generates the pdf file';
        });
    }
</script>