vcav
====

VIDEO CHARACTERIZATION ANALYSIS VIEWER

Video preservationists rely heavily on characterization tools to understand the significant properties of the content they are working with. Important attributes to understand include file format, # of tracks, track encoding format(s), duration, frame rate, chroma subsampling, aspect ratio, colorspace, etc.

Typically repositories dealing with video preservation will use tools such as MediaInfo, Exiftool, or ffprobe (among others) in order to characterize content. However, it has been recently observed by video art conservators that these tools can produce vastly different output from one another, to the point where duration can be off by minutes. This is clearly a problem.

In order to help video preservationists best understand and analyze their content it is important to first understand the behavior of these tools.

This proposal is to create a simple viewer that will display selected attributes from multiple tools, and highlight differences between them. The viewer should also display the name and version of the tool that has been used. Ideally this could be used for batches of video at once, but one at a time would be a good start.

Inspired and intended to aid the work of Joanna Phillips (Guggenheim), Agathe Jarczkyk (Bern University of the Arts), and Erik Piil (Anthology / DuArt).

