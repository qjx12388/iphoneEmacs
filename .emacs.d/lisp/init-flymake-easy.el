;;flymake-easy config
(add-to-list 'load-path "~/.emacs.d/elpa/flymake-easy-0.9")
(require 'flymake-easy)
(add-hook 'objc-mode 'flymake-easy-autoloads)
(provide 'init-flymake-easy)
