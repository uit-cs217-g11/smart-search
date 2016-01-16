﻿using System;
using System.Collections;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace LollipopUI
{
    public partial class MainForm : Form
    {
		BackgroundWorker m_inputRawWorker;
		BackgroundWorker m_inputTokenizedWorker;
		BackgroundWorker m_tokenizingWorker;
		BackgroundWorker m_indexingWorker;

		private string m_inputRaw;
		private string m_inputTokenized;
		private string m_inputIndexed;

		private string m_outputDirectory;
		private string m_untokenizedOutputDirectory;

		public MainForm()
        {
            InitializeComponent();

			//Dictionary.Sync("vietnamese-stopwords.txt", "vietnamese-stopwords.txt");

			Dictionary.LoadWordsList("Viet74K.txt");
			Dictionary.LoadWordsList("TechicalWordsLibrary.txt");

			Dictionary.LoadStopWords("vietnamese-stopwords.txt");

			SetupBackgroundWorker();
		}

		private void btn_tokenize_Click(object sender, EventArgs e)
		{
			if(txtbox_input.Text == "")
			{
				MessageBox.Show("Please select a folder for tokenizing!!!");
				return;
			}

			FolderBrowserDialog _dialog = new FolderBrowserDialog();
			if (_dialog.ShowDialog() != DialogResult.OK)
				return;

			m_outputDirectory = _dialog.SelectedPath.Replace("\r", String.Empty);

			FolderBrowserDialog _dialogUntokenized = new FolderBrowserDialog();
			if (_dialogUntokenized.ShowDialog() != DialogResult.OK)
				return;

			m_untokenizedOutputDirectory = _dialogUntokenized.SelectedPath.Replace("\r", String.Empty);

			m_tokenizingWorker.RunWorkerAsync();

			btn_tokenize.Enabled = false;
			btn_indexing.Enabled = false;
			btn_canceled_indexing.Enabled = false;

			browse_folder_raw.Enabled = false;
			browse_folder_tokenized.Enabled = false;
		}

		private void btn_indexing_Click(object sender, EventArgs e)
		{
			if (txtbox_tokenized.Text == "")
			{
				MessageBox.Show("Please select a folder for indexing!!!");
				return;
			}

			FolderBrowserDialog _dialog = new FolderBrowserDialog();
			if (_dialog.ShowDialog() != DialogResult.OK)
				return;

			m_outputDirectory = _dialog.SelectedPath.Replace("\r", String.Empty);

			m_indexingWorker.RunWorkerAsync();

			btn_tokenize.Enabled = false;
			btn_indexing.Enabled = false;
			btn_canceled_tokenize.Enabled = false;

			browse_folder_raw.Enabled = false;
			browse_folder_tokenized.Enabled = false;
		}

		private void browse_folder_raw_TextChanged(object sender, EventArgs e)
		{
			m_inputRawWorker.RunWorkerAsync();
		}

		private void browse_folder_tokenized_TextChanged(object sender, EventArgs e)
		{
			m_inputTokenizedWorker.RunWorkerAsync();
		}

		private void timer_Tick(object sender, EventArgs e)
		{
			txtbox_input.Text = m_inputRaw;
			txtbox_tokenized.Text = m_inputTokenized;
			txtbox_indexed.Text = m_inputIndexed;
		}

		private void progress_bar_ProgressChanged(object sender, ProgressChangedEventArgs e)
		{
			progress_bar.Value = e.ProgressPercentage;
		}

		private void btn_canceled_tokenize_Click(object sender, EventArgs e)
		{
			m_tokenizingWorker.CancelAsync();

			btn_tokenize.Enabled = true;
			btn_indexing.Enabled = true;
			btn_canceled_indexing.Enabled = true;

			browse_folder_raw.Enabled = true;
			browse_folder_tokenized.Enabled = true;

			Dictionary.Sync("TechicalWordsLibrary.txt", "TechicalWordsLibrary.txt");
		}

		private void btn_canceled_indexing_Click(object sender, EventArgs e)
		{
			m_indexingWorker.CancelAsync();

			btn_tokenize.Enabled = true;
			btn_indexing.Enabled = true;
			btn_canceled_tokenize.Enabled = true;

			browse_folder_raw.Enabled = true;
			browse_folder_tokenized.Enabled = true;
		}

		private void SetupBackgroundWorker()
		{
			m_inputRawWorker = new BackgroundWorker();
			m_inputRawWorker.DoWork += new DoWorkEventHandler(m_inputRawWorker_DoWork);
			m_inputRawWorker.ProgressChanged += new ProgressChangedEventHandler(progress_bar_ProgressChanged);
			m_inputRawWorker.RunWorkerCompleted += new RunWorkerCompletedEventHandler(m_inputRawWorker_RunWorkerCompleted);
			m_inputRawWorker.WorkerReportsProgress = true;
			m_inputRawWorker.WorkerSupportsCancellation = true;

			m_inputTokenizedWorker = new BackgroundWorker();
			m_inputTokenizedWorker.DoWork += new DoWorkEventHandler(m_inputTokenizedWorker_DoWork);
			m_inputTokenizedWorker.ProgressChanged += new ProgressChangedEventHandler(progress_bar_ProgressChanged);
			m_inputTokenizedWorker.RunWorkerCompleted += new RunWorkerCompletedEventHandler(m_inputTokenizedWorker_RunWorkerCompleted);
			m_inputTokenizedWorker.WorkerReportsProgress = true;
			m_inputTokenizedWorker.WorkerSupportsCancellation = true;

			m_tokenizingWorker = new BackgroundWorker();
			m_tokenizingWorker.DoWork += new DoWorkEventHandler(m_tokenizingWorker_DoWork);
			m_tokenizingWorker.ProgressChanged += new ProgressChangedEventHandler(progress_bar_ProgressChanged);
			m_tokenizingWorker.RunWorkerCompleted += new RunWorkerCompletedEventHandler(m_tokenizingWorker_RunWorkerCompleted);
			m_tokenizingWorker.WorkerReportsProgress = true;
			m_tokenizingWorker.WorkerSupportsCancellation = true;

			m_indexingWorker = new BackgroundWorker();
			m_indexingWorker.DoWork += new DoWorkEventHandler(m_indexingWorker_DoWork);
			m_indexingWorker.ProgressChanged += new ProgressChangedEventHandler(progress_bar_ProgressChanged);
			m_indexingWorker.RunWorkerCompleted += new RunWorkerCompletedEventHandler(m_indexingWorker_RunWorkerCompleted);
			m_indexingWorker.WorkerReportsProgress = true;
			m_indexingWorker.WorkerSupportsCancellation = true;
		}

		private void m_inputRawWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			MessageBox.Show("Get raw data complete. Please click button Tokenizing to tokenize...");
		}

		private void m_inputRawWorker_DoWork(object sender, DoWorkEventArgs e)
		{
			string directory = browse_folder_raw.Text;

			try
			{
				DirectoryInfo _directInfo = new DirectoryInfo(directory);
				FileInfo[] files = _directInfo.GetFiles();
				int _currentFile = 0;
				m_inputRawWorker.ReportProgress(0);

				txtbox_input.Text = "";

				foreach (FileInfo file in files)
				{
					m_inputRaw += file.FullName + Environment.NewLine;
					_currentFile++;

					m_inputRawWorker.ReportProgress(_currentFile * 100 / files.Count());
				}
			}
			catch
			{
				MessageBox.Show("Invalid folder. Please select a folder for tokenizing!!!");
			}
		}

		private void m_inputTokenizedWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			MessageBox.Show("Get tokenized data complete. Please click button Indexing to index...");
		}

		private void m_inputTokenizedWorker_DoWork(object sender, DoWorkEventArgs e)
		{
			string directory = browse_folder_tokenized.Text;

			try
			{
				DirectoryInfo _directInfo = new DirectoryInfo(directory);
				FileInfo[] files = _directInfo.GetFiles();
				int _currentFile = 0;
				m_inputTokenizedWorker.ReportProgress(0);

				m_inputTokenized = "";

				foreach (FileInfo file in files)
				{
					m_inputTokenized += file.FullName + Environment.NewLine;
					_currentFile++;

					m_inputTokenizedWorker.ReportProgress(_currentFile * 100 / files.Count());
				}
			}
			catch
			{
				MessageBox.Show("Invalid folder. Please select a folder for indexing!!!");
			}
		}

		private void m_tokenizingWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			if(e.Cancelled)
				MessageBox.Show("Process is canceled. Possible losing data...");
			else
				MessageBox.Show("Tokenize completed. Please click button Indexing to index...");
		}

		private void m_tokenizingWorker_DoWork(object sender, DoWorkEventArgs e)
		{
			string[] _lines = txtbox_input.Lines;

			try
			{
				int _currentProgress = 0;
				m_tokenizingWorker.ReportProgress(0);

				foreach (string _line in _lines)
				{
					try
					{
						string _inputPath = _line.Replace("\r", String.Empty);
						var _readStream = new System.IO.FileStream(_inputPath,
										  System.IO.FileMode.Open,
										  System.IO.FileAccess.Read,
										  System.IO.FileShare.ReadWrite);
						var _reader = new System.IO.StreamReader(_readStream, System.Text.Encoding.UTF8, true, 128);

						string _id = _reader.ReadLine();
						string _friendly_url = _reader.ReadLine();
						string _title = _reader.ReadLine();
						string _tags = _reader.ReadLine();
						string _content = _reader.ReadToEnd();

						_reader.Dispose();
						_readStream.Dispose();


						Tokenizer _tokenizer = new Tokenizer();
						ArrayList _result = _tokenizer.Tokenizing(_content, true, m_untokenizedOutputDirectory + "\\" + _id + '-' + _friendly_url + ".not");


						string _outputPath = m_outputDirectory + "\\" + _id + '-' + _friendly_url + ".tok";
						var _writetream = new System.IO.FileStream(_outputPath,
										  System.IO.FileMode.Create,
										  System.IO.FileAccess.Write,
										  System.IO.FileShare.ReadWrite);
						var _writer = new System.IO.StreamWriter(_writetream, System.Text.Encoding.UTF8, 128);
						_writer.Write(_id + Environment.NewLine + _friendly_url + Environment.NewLine +
										_title + Environment.NewLine + _tags + Environment.NewLine +
										string.Join(Environment.NewLine, _result.ToArray(typeof(string)) as string[]));

						_writer.Dispose();
						_writetream.Dispose();

						m_inputTokenized += _outputPath + Environment.NewLine;

						_currentProgress++;
						m_tokenizingWorker.ReportProgress(_currentProgress * 100 / _lines.Count());

						if(m_tokenizingWorker.CancellationPending)
						{
							e.Cancel = true;
							return;
						}
					}
					catch
					{

					}
				}
			}
			catch
			{
				MessageBox.Show("No file to tokenize. Process failed...");
			}
		}

		private void m_indexingWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			if (e.Cancelled)
				MessageBox.Show("Process is canceled. Possible losing data...");
			else
				MessageBox.Show("Indexed data completed...");
		}

		private void m_indexingWorker_DoWork(object sender, DoWorkEventArgs e)
		{
			string[] _lines = txtbox_tokenized.Lines;

			try
			{
				foreach (string _line in _lines)
				{
					try
					{
						string _inputPath = _line.Replace("\r", String.Empty);
						var _readStream = new System.IO.FileStream(_inputPath,
										  System.IO.FileMode.Open,
										  System.IO.FileAccess.Read,
										  System.IO.FileShare.ReadWrite);
						var _reader = new System.IO.StreamReader(_readStream, System.Text.Encoding.UTF8, true, 128);

						string _id = _reader.ReadLine();
						string _friendly_url = _reader.ReadLine();
						string _title = _reader.ReadLine();
						string _tags = _reader.ReadLine();
						ArrayList _wordsTokenized = new ArrayList();
						string _wordToken = null;

						while ((_wordToken = _reader.ReadLine()) != null)
						{
							_wordsTokenized.Add(_wordToken);
						}

						_reader.Dispose();
						_readStream.Dispose();


						Indexer _indexer = new Indexer();
						ArrayList _result = _indexer.Indexing(_title, _tags, _wordsTokenized);


						string _outputPath = m_outputDirectory + "\\" + _id + '-' + _friendly_url + ".ind";
						var _writetream = new System.IO.FileStream(_outputPath,
										  System.IO.FileMode.Create,
										  System.IO.FileAccess.Write,
										  System.IO.FileShare.ReadWrite);
						var _writer = new System.IO.StreamWriter(_writetream, System.Text.Encoding.UTF8, 128);
						_writer.Write(_id + Environment.NewLine + _friendly_url + Environment.NewLine +
										_title + Environment.NewLine + _tags + Environment.NewLine);

						foreach (Word _word in _result)
						{
							_writer.WriteLine(_word.m_content + '|' + _word.m_weight + '|' + 1);
						}

						_writer.Dispose();
						_writetream.Dispose();

						m_inputIndexed += _outputPath + Environment.NewLine;

						if (m_indexingWorker.CancellationPending)
						{
							e.Cancel = true;
							return;
						}
					}
					catch
					{

					}
				}
			}
			catch
			{
				MessageBox.Show("No file to tokenize. Process failed...");
			}
		}
	}
}
