(add-to-list 'load-path "~/.emacs.d/elpa/emacs-xcode-document-viewer")
(require 'xcode-document-viewer)
(setq xcdoc:document-path "/Users/corrin/Library/Developer/Shared/Documentation/DocSets/com.apple.adc.documentation.AppleiOS8.1.iOSLibrary.docset")
(setq xcode:open-w3m-other-buffer t)

(provide 'init-xcode-document-viewer)