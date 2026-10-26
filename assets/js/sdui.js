/* COSULTA Server-Driven UI renderer
 * The PHP endpoint supplies a JSON component schema; this file only renders approved component types.
 */
(() => {
  'use strict';
  const root = document.getElementById('sdui-root');
  if (!root) return;

  const make = (tag, className, text) => {
    const node = document.createElement(tag);
    if (className) node.className = className;
    if (text !== undefined && text !== null) node.textContent = String(text);
    return node;
  };
  const safeHref = (href) => {
    const value = String(href || '');
    // Internal application links only; prevent javascript: and external injection.
    return /^(?!\s*(javascript:|data:|https?:))/i.test(value) ? value : '#';
  };
  const makeLink = (action, className) => {
    const link = make('a', className, action && action.label ? action.label : 'فتح');
    link.href = safeHref(action && action.href);
    return link;
  };

  function renderComponent(component) {
    switch (component.type) {
      case 'hero': {
        const section = make('section', 'hero sdui-hero');
        section.append(make('span', 'tag', component.tag || ''));
        section.append(make('h1', '', component.title || ''));
        const paragraph = make('p', '', component.text || '');
        section.append(paragraph, makeLink(component.action, 'btn light'));
        return section;
      }
      case 'heading':
        return make('h2', 'sdui-heading', component.text || '');
      case 'provider_grid': {
        const grid = make('div', 'grid');
        (Array.isArray(component.items) ? component.items : []).forEach((item) => {
          if (item.type !== 'provider_card') return;
          const card = make('article', 'card');
          card.append(make('span', 'tag', item.specialization || ''));
          card.append(make('h3', '', item.title || ''));
          card.append(make('p', '', item.name || ''));
          card.append(make('p', 'muted', item.description || ''));
          card.append(make('p', 'price', `${item.price || '0.00'} د.ل`));
          card.append(makeLink(item.action, 'btn'));
          grid.append(card);
        });
        return grid;
      }
      case 'empty_state': {
        const card = make('div', 'card sdui-empty');
        card.append(make('h3', '', component.title || 'لا توجد بيانات'));
        card.append(make('p', '', component.text || ''));
        return card;
      }
      default:
        // Unknown component types are ignored rather than interpreted as HTML.
        return null;
    }
  }

  async function loadUI() {
    root.setAttribute('aria-busy', 'true');
    try {
      const response = await fetch('api/ui.php', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
      if (!response.ok) throw new Error('UI request failed');
      const payload = await response.json();
      if (!payload.success || !payload.ui || !Array.isArray(payload.ui.components)) throw new Error('Invalid UI schema');
      const fragment = document.createDocumentFragment();
      payload.ui.components.forEach((component) => {
        const node = renderComponent(component);
        if (node) fragment.append(node);
      });
      root.replaceChildren(fragment);
    } catch (error) {
      root.replaceChildren(make('div', 'error', 'تعذر تحميل الواجهة من الخادم. أعيدي تحميل الصفحة أو تحققي من تشغيل PHP وMySQL.'));
    } finally {
      root.removeAttribute('aria-busy');
    }
  }
  loadUI();
})();
