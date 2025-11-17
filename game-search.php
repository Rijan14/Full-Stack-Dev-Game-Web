<?php include "db-game.php"; ?>
<?php include "navigation.html"; ?>

<!doctype html>
<html>
<head>
  <title>Search Games</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <h2 class="mb-4">Search Games</h2>

  <form onsubmit="return false;" class="row g-2 mb-3">
    <div class="col-md-4"><input id="s_title" class="form-control" placeholder="Title keyword"></div>
    <div class="col-md-3"><input id="s_genre" class="form-control" placeholder="Genre"></div>
    <div class="col-md-3"><input id="s_platform" class="form-control" placeholder="Platform"></div>
    <div class="col-md-2"><input id="s_year" type="number" class="form-control" placeholder="Year"></div>
  </form>

  <div id="searchResults"></div>
</div>

<script>
function escapeHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

async function doSearch(){
  const params = new URLSearchParams({
    title: document.getElementById('s_title').value,
    genre: document.getElementById('s_genre').value,
    platform: document.getElementById('s_platform').value,
    year: document.getElementById('s_year').value,
    q: ''  // fallback search
  });
  const res = await fetch('https://mi-linux.wlv.ac.uk/~2406957/game-ajax.php?'+params.toString());
  const data = await res.json();
  const out = document.getElementById('searchResults');
  if (!data.length) { out.innerHTML = '<div class="alert alert-info">No results found</div>'; return; }
  let html = '<table class="table table-striped"><thead><tr><th>Title</th><th>Genre</th><th>Platform</th><th>Year</th><th></th></tr></thead><tbody>';
  data.forEach(g => {
    html += `<tr>
      <td>${escapeHtml(g.title)}</td>
      <td>${escapeHtml(g.genre)}</td>
      <td>${escapeHtml(g.platform)}</td>
      <td>${escapeHtml(g.published_year)}</td>
      <td><a href="game-details.php?id=${g.id}" class="btn btn-sm btn-info">View</a></td>
    </tr>`;
  });
  html += '</tbody></table>';
  out.innerHTML = html;
}

document.getElementById('s_title').addEventListener('input', doSearch);
document.getElementById('s_genre').addEventListener('input', doSearch);
document.getElementById('s_platform').addEventListener('input', doSearch);
document.getElementById('s_year').addEventListener('input', doSearch);
</script>

</body>
</html>
