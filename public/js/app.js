function initTooltip() {
    $('[data-toggle="tooltip"]').tooltip()
}


function initSelect2() {
  $('.select2-field').select2({
    theme: 'bootstrap',
    width: '100%'
  });
}

function handleMethodLinks() {
    const _token = document.head.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
    document.querySelectorAll('[data-method]').forEach(link => {
        link.addEventListener('click', function (event) {
        event.preventDefault();
        const url = this.getAttribute('href');
        const confirmation = this.getAttribute('data-confirm');
        const method = this.getAttribute('data-method') || 'POST';

        if (confirmation && !confirm(confirmation)) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.style.display = 'none';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = _token;
        form.appendChild(tokenInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = method.toUpperCase();
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
        });
    });
}

function handlePushMenuToggle() {
  $('[data-widget="pushmenu"]').on('click', function () {
    const sidebarStatus = $('body').hasClass('sidebar-collapse') ? 'open' : 'closed';
    const date = new Date();
    date.setTime(date.getTime() + (24 * 60 * 60 * 1000));
    document.cookie = `sidebarStatus=${sidebarStatus}; expires=${date.toUTCString()}; path=/`;
  });
}

document.addEventListener('DOMContentLoaded', function () {
    initTooltip()
    initSelect2();
    handleMethodLinks();
    handlePushMenuToggle();
});