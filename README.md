<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
             <title>Document</title>

</head>
<body>

<clipboard-copy for="blob-path"> Copy </clipboard-copy>
<div id="blob-path">src/index.js</div>

</body>
<script>
document.addEventListener('clipboard-copy', function(event) {
  const button = event.target;
  button.classList.add('highlight')
})
</script>
<script type="module" src="./node_modules/@github/clipboard-copy-element/dist/index.js" ></script>
</html>

