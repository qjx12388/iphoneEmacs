;;config org mode
(add-to-list 'load-path "~/.emacs.d/elpa/org-20150302")

(require 'org)

(add-hook 'objc-mode 'org-mode)

(provide 'init-org)
