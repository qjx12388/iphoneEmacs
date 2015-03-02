;; iedit config
(add-to-list 'load-path "~/.emacs.d/elpa/iedit")
(require 'iedit)


(add-hook 'objc-mode 'iedit-mode)
(provide 'init-iedit)
