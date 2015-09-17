;;config for js2-mode
(add-to-list 'load-path "~/.emacs.d/elpa/js2-mode-20150630.1336")
(require 'js2-mode)

(add-to-list 'auto-mode-alist '("\\.js$" . js2-mode))
(add-hook 'js-mode-hook 'js2-minor-mode)

(provide 'init-js2-mode)
