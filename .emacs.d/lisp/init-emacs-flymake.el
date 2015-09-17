;;config for flymake
(add-to-list 'load-path "~/.emacs.d/elpa/emacs-flymake")
(require 'flymake)

(add-hook 'objc-mode-hook
          (lambda()(flymake-mode t)))

(provide 'init-emacs-flymake)
