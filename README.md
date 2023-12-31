<script type="module" src="./node_modules/@github/clipboard-copy-element/dist/index.js" ></script>


<clipboard-copy class="btn"
for="blob-path"> Copy 
</clipboard-copy>
<div id="blob-path">src/index.js</div>


<script>
document.addEventListener('clipboard-copy', function(event) {
  const button = event.target;
  button.classList.add('highlight')
})
</script>

