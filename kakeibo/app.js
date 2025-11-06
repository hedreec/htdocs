
(function(){
  const rows = document.getElementById('rows');
  const addBtn = document.getElementById('add');

  function rowNode(){
    const wrap = document.createElement('div');
    wrap.className = 'grid row';
    wrap.innerHTML = `
      <div><input type="date" name="event_date[]" required></div>
      <div>
        <select name="category[]">
          <option>交通費</option><option>飲食</option><option>買い物</option><option>その他</option>
        </select>
      </div>
      <div><input type="text" name="place[]" required placeholder="例：三宮まで / 立ち食い蕎麦"></div>
      <div><input type="number" name="amount[]" min="1" step="1" required></div>
      <div><button type="button" class="btn remove" title="行を削除">−</button></div>
    `;
    return wrap;
  }

  addBtn.addEventListener('click', ()=> rows.appendChild(rowNode()));
  rows.addEventListener('click', (e)=>{
    if(e.target.classList.contains('remove')){
      const r = e.target.closest('.row');
      if (rows.children.length > 1) r.remove();
    }
  });
})();
