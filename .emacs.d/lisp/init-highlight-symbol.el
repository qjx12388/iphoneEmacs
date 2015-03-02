;;config highlight symbol
(add-to-list 'load-path "~/.emacs.d/elpa/highlight-symbol-1.1")
(require 'highlight-symbol)

(global-set-key (kbd "C--") 'highlight-symbol-at-point)
(global-set-key (kbd "C-c j") 'highlight-symbol-next)
(global-set-key (kbd "C-c k") 'highlight-symbol-prev)
(global-set-key (kbd "C-c r") 'highlight-symbol-query-replace)

;;(add-hook 'objc-mode 'highlight-symbol)
(provide 'init-highlight-symbol)
