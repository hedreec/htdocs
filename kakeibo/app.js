
(function(){
  const rows = document.getElementById('rows');
  const addBtn = document.getElementById('add');
  const today = new Date().toISOString().slice(0,10);

  function rowNode() {
    const wrap = document.createElement('div');
    wrap.className = 'grid row';
    wrap.innerHTML = `
      <div><input type="date" name="event_date[]" required value="${today}"></div>
      <div>
        <select name="category[]">
          <option>交通費</option><option>飲食</option><option>買い物</option><option>その他</option>
        </select>
      </div>
      <div><input type="text" name="place[]" required placeholder="例：三宮まで / 立ち食い蕎麦"></div>
      <div><input type="number" name="amount[]" min="1" step="1" required></div>
      <div><button type="button" class="btn remove" data-remove="1" title="行を削除">−</button></div>
    `;
    return wrap;
  }

  addBtn.addEventListener('click', ()=> rows.appendChild(rowNode()));

  document.addEventListener('click', (e)=>{
    const btn = e.target.closest('button.remove[data-remove]');
    if (!btn) return;
    const r = btn.closest('.row');
    if (r && rows.contains(r)) {
      if (rows.children.length > 1) r.remove();
    }
  });
})();
